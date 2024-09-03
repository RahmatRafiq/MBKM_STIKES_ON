import Navbar from "@/Components/Navbar";

type Props = {
  children: React.ReactNode;
}

const Guest = ({ children }: Props) => {

  return (
    <>
      <Navbar />
      <main>
        {children}
      </main>
    </>
  );
}

export default Guest;
